import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PersonasForm } from './personas-form';

describe('PersonasForm', () => {
  let component: PersonasForm;
  let fixture: ComponentFixture<PersonasForm>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [PersonasForm],
    }).compileComponents();

    fixture = TestBed.createComponent(PersonasForm);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
