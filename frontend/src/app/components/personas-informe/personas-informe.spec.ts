import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PersonasInforme } from './personas-informe';

describe('PersonasInforme', () => {
  let component: PersonasInforme;
  let fixture: ComponentFixture<PersonasInforme>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [PersonasInforme],
    }).compileComponents();

    fixture = TestBed.createComponent(PersonasInforme);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
